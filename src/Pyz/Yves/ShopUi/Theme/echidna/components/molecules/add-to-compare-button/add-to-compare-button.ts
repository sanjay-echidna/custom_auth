import $ from 'jquery/dist/jquery';
import Swal from 'sweetalert2'
import Component from 'ShopUi/models/component';


export default class AddToCompareButton extends Component {
    protected readyCallback(): void {
    }

    protected init(): void {
        super.init();
    }

}
$(document).ready(() => {
    const headersList = {
        "Accept": "*/*",
        "User-Agent": "*/*",
        "Content-Type": "application/json"
    };

    async function fetchData(sku) {
        const bodyContent = JSON.stringify({
            "sku": sku
        });

        try {
            const response = await fetch("/product-compare/add", {
                method: "POST",
                body: bodyContent,
                headers: headersList
            });

            if (response.ok) {
                const data = await response.json();

                Swal.fire({
                    icon: data.status,
                    title: data.status,
                    text: data.msg,
                    showCancelButton: true,
                    confirmButtonText: 'View Compare Products',
                    cancelButtonText: 'Continue'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/product-compare/view';
                    }
                })
            } else {
                throw new Error(response.statusText);
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message
            });

        }
    }

    $(".button__compare").click(function (e) {
        e.preventDefault();
        const sku = $(this).attr("data");

        if (sku) {
            fetchData(sku);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'SKU not found'
            });

        }
    });
});
