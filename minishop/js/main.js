// ===== 1. Hàm tiện ích =====

// Định dạng số thành tiền Việt: 250000 -> "250.000 đ"
function formatPrice(amount) {
    return amount.toLocaleString("vi-VN") + " đ";
}

// ===== 2. Giỏ hàng lưu tạm trong trình duyệt =====
const CART_KEY = "minishop_cart";

function getCart() {
    const data = localStorage.getItem(CART_KEY);
    return data ? JSON.parse(data) : {};
}

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

function updateCartCount() {
    const cart = getCart();
    let count = 0;
    for (const id in cart) {
        count += cart[id];
    }
    const badge = document.querySelector("#cart-count");
    if (badge) {
        badge.textContent = count;
    }
}

function addToCart(id) {
    const cart = getCart();
    cart[id] = (cart[id] || 0) + 1;
    saveCart(cart);
    updateCartCount();
}

// Gắn sự kiện click cho mọi nút "Thêm vào giỏ"
document.querySelectorAll(".add-to-cart").forEach(function (button) {
    button.addEventListener("click", function () {
        addToCart(button.dataset.id);
    });
});

// Hiện số lượng ngay khi trang vừa mở
updateCartCount();

// ===== 3. Trang giỏ hàng: tự tính thành tiền và tổng cộng =====
function updateCartTotals(table) {
    let total = 0;
    table.querySelectorAll("tbody tr").forEach(function (row) {
        const price = Number(row.dataset.price);
        const qty = Number(row.querySelector(".qty").value);
        const lineTotal = price * qty;
        row.querySelector(".line-total").textContent = formatPrice(lineTotal);
        total += lineTotal;
    });
    document.querySelector("#cart-total").textContent = formatPrice(total);
}

const cartTable = document.querySelector(".cart-table");
if (cartTable) {
    cartTable.addEventListener("input", function () {
        updateCartTotals(cartTable);
    });
    updateCartTotals(cartTable);
}

// ===== 4. Form đăng ký: hai mật khẩu phải khớp nhau =====
const registerForm = document.querySelector("#register-form");
if (registerForm) {
    registerForm.addEventListener("submit", function (event) {
        const password = document.querySelector("#password").value;
        const password2 = document.querySelector("#password2").value;
        const error = document.querySelector("#password-error");

        if (password !== password2) {
            event.preventDefault();
            error.textContent = "Hai mật khẩu không khớp nhau.";
        } else {
            error.textContent = "";
        }
    });
}

// ===== 5. Xóa giỏ hàng với xác nhận =====
const clearCartBtn = document.querySelector("#clear-cart");
if (clearCartBtn) {
    clearCartBtn.addEventListener("click", function () {
        if (confirm("Xóa toàn bộ giỏ hàng?")) {
            localStorage.removeItem(CART_KEY);
            updateCartCount();
            const cartTable = document.querySelector(".cart-table");
            if (cartTable) {
                updateCartTotals(cartTable);
            }
        }
    });
}

// ===== 6. Kiểm tra form liên hệ =====
const contactForm = document.querySelector("#contact-form");
if (contactForm) {
    contactForm.addEventListener("submit", function (event) {
        const messageInput = document.querySelector("#message");
        const errorSpan = document.querySelector("#message-error");

        if (messageInput && messageInput.value.length < 10) {
            event.preventDefault();
            if (errorSpan) {
                errorSpan.textContent = "Nội dung tin nhắn phải từ 10 ký tự trở lên.";
            }
        }
    });
}
