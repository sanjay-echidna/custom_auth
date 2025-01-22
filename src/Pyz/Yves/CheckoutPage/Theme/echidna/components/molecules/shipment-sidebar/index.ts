import './shipment-sidebar.scss';

const methodIcon = document.getElementById("shipment-block");
const shipmentList = document.getElementById("shipment-list");
if (methodIcon != null) {
    methodIcon.addEventListener("click", function () {
        this.classList.toggle("active");
        shipmentList.classList.remove("is-hidden");
        if (shipmentList.style.maxHeight) {
            shipmentList.style.maxHeight = null;
            shipmentList.classList.add("is-hidden");
        } else {
            shipmentList.style.maxHeight = shipmentList.scrollHeight + "px";
        }
    });

}
