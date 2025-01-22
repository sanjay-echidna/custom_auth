import Component from "ShopUi/models/component";

export default class CameraModal extends Component {
    protected uploadButton: HTMLElement;
    protected captureButton: HTMLElement;
    protected canvas;
    protected video;
    protected fileInput: HTMLInputElement;
    protected imagePreview: HTMLImageElement;
    protected button: HTMLElement;
    protected modal: HTMLElement;
    protected closeButton: HTMLElement;

    protected readyCallback(): void {}

    protected init(): void {
        this.captureButton = <HTMLElement>document.getElementById('captureBtn');
        this.canvas = <HTMLElement>document.getElementById('canvas');
        this.button = <HTMLElement>document.getElementById('cameraButton');
        this.video = <HTMLElement>document.getElementById('camera')
        this.uploadButton = <HTMLElement>document.getElementById('uploadBtn');
        this.fileInput = <HTMLInputElement>document.getElementById('image_upload_form_image');
        this.imagePreview = <HTMLImageElement>document.getElementById('imagePreview');
        this.modal = <HTMLElement>document.getElementById('modal-1');
        this.closeButton = <HTMLElement>document.getElementById('closeBtn');

        this.mapEvents();
    }

    protected mapEvents(): void {
        this.button.addEventListener('click', (event: Event) => this.showModal(event));
        this.captureButton.addEventListener('click', (event: Event) => this.captureImage(event));
        this.fileInput.addEventListener('change', (event: Event) => this.previewImage(event));
        this.uploadButton.addEventListener('click', (event: Event) => this.uploadImage(event));
        this.closeButton.addEventListener('click', (event: Event) => this.closeModal());
        window.addEventListener('click', (event: Event) => this.outsideClick(event));
    }

    protected showModal(event): void {
        this.startCamera();
        this.modal.style.display = 'block';
    }

    // Close modal
    protected closeModal(): void {
        this.modal.style.display = 'none';
    }

    // Click outside and close
    protected outsideClick(event: Event): void {
        if (event.target === this.modal) {
            this.closeModal();
        }
    }

    // Preview image
    protected previewImage(event: Event): void {
        const file = this.fileInput.files?.[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e: ProgressEvent<FileReader>) => {
                if (e.target?.result) {
                    this.imagePreview.src = e.target.result as string;
                    this.imagePreview.style.display = 'block';
                }
            };
            reader.readAsDataURL(file);
        }
    }

    // Upload image
    protected async uploadImage(event: Event): Promise<void> {
        const file = this.fileInput.files?.[0];
        if (!file) {
            alert('Please select an image to upload.');
            return;
        }

        const csrfToken = (document.querySelector('[name="_token_snap_find"]') as HTMLInputElement)?.value;
        const formData = new FormData();
        formData.append('image_upload_form[image]', file);
        formData.append('_token', csrfToken);

        const loader = document.getElementById('loader');

        try {

            loader.style.display = 'flex';

            const response = await fetch('http://yves.us.spryker.local/snap-find', {
                method: 'POST',
                body: formData,
            });

            let result = await response;
            console.log(result);
            if (result.ok) {
                const redirectUrl = result.url;
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                } else {
                    console.error('Redirect URL not found in response headers.');
                }
            } else {
                console.error('Failed to upload image:', response.statusText);
            }
        } catch (error) {
            console.error('Error uploading image:', error);
        } finally {
            // Hide loader
            loader.style.display = 'none';
        }
    }

    protected captureImage(event) {
        const context = this.canvas.getContext('2d');

        // Set canvas size to video size
        this.canvas.width = this.video.videoWidth;
        this.canvas.height = this.video.videoHeight;

        // Draw the current frame of the video onto the canvas
        context.drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height);

        // Convert canvas to Blob (binary data)
        this.canvas.toBlob(async function (blob) {

            // Create a FormData object and append the image as a file
            const formData = new FormData();
            formData.append('image_upload_form[image]', blob, 'captured_image.jpg');

            // Send the image to the server
            try {
                const response = await fetch('http://yves.us.spryker.local/snap-find', {
                    method: 'POST',
                    body: formData,
                });

                const result = await response;
                window.location.href = result.url;
            } catch (error) {
                console.error('Error uploading image:', error);
            }
        }, 'image/jpeg'); // Specify the image format (JPEG)
    }

    async startCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: true,
            });
            this.video.srcObject = stream;
        } catch (error) {
            console.error('Error accessing camera:', error);
        }
    }

    async stopCamera() {
        const videoEl = document.getElementById('camera');
        // now get the steam
        const stream = videoEl.srcObject;
        const tracks = stream.getTracks();
        // now close each track by having forEach loop
        tracks.forEach(function(track) {
            // stopping every track
            track.stop();
        });
        // assign null to srcObject of video
        videoEl.srcObject = null;
    }

}
