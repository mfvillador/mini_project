

function openViewItems() {
    document.getElementById("showCart").style.display = "none";
    document.getElementById("yourOrder").style.display = "none";
    document.getElementById("viewItem").style.display = "block";
}

function closeViewItems() {
    document.getElementById("viewItem").style.display = "none";
}

function openShowCart() {
    document.getElementById("viewItem").style.display = "none";
    document.getElementById("yourOrder").style.display = "none";
    document.getElementById("showCart").style.display = "block";
}

function closeShowCart() {
    document.getElementById("showCart").style.display = "none";
}

function openYourOrder() {
    document.getElementById("viewItem").style.display = "none";
    document.getElementById("showCart").style.display = "none";
    document.getElementById("yourOrder").style.display = "block";
}

function closeYourOrder() {
    document.getElementById("yourOrder").style.display = "none";
}

function ableCheckoutButton() {
    document.getElementById("checkout_button").disabled = false;
}