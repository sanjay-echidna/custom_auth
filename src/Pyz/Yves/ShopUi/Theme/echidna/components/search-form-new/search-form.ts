import Component from "ShopUi/models/component";

export default class SearchForm extends Component {
    protected button;
    protected modal;
    protected cameraButtonMini;
    protected video;

    protected readyCallback(): void {}

    protected init(): void {
        this.button = <HTMLElement>document.getElementById('cameraButton');
        this.modal = <HTMLElement>document.getElementById('modal-1');
        this.cameraButtonMini = <HTMLElement>document.getElementById('cameraButtonMini');
        this.video = <HTMLElement>document.getElementById('camera');

        this.mapEvents();
    }

    protected mapEvents(): void {
        this.button.addEventListener('click', (event: Event) => this.showModal(event));
        this.cameraButtonMini.addEventListener('click', (event: Event) => this.showModal(event));
    }

    protected showModal(event) {
        this.modal.style.display = "block";
        this.startCamera();
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
}
