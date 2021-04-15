

function openViewItems() {
    document.getElementById("viewOrder").style.display = "none";
    document.getElementById("viewItem").style.display = "block";
}

function closeViewItems() {
    document.getElementById("viewItem").style.display = "none";
}

function openViewOrders() {
    document.getElementById("viewItem").style.display = "none";
    document.getElementById("viewOrder").style.display = "block";
}

function closeViewOrders() {
    document.getElementById("viewOrder").style.display = "none";
}

function ableDeliverButton() {
    document.getElementById("deliver_button").disabled = false;
}