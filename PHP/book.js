// Calculate age
function calculateAge() {
  let dob = document.getElementById("birth_date").value;
  if (dob) {
    let birthDate = new Date(dob);
    let today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    let m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
      age--;
    }
    document.getElementById("age").value = age;
  }
}

// Update price when destination selected
function updatePrice() {
  const destinationSelect = document.getElementById("destination");
  const selectedOption =
    destinationSelect.options[destinationSelect.selectedIndex];
  const price = selectedOption.dataset.price || 0;
  document.getElementById("price").value = price;
}

// Validate before payment
function validateForm() {
  let mobile = document.getElementById("mobile").value;
  let email = document.getElementById("email").value;

  let mobilePattern = /^[0-9]{10}$/;
  if (!mobilePattern.test(mobile)) {
    alert("Enter a valid 10-digit mobile number!");
    return false;
  }

  let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    alert("Enter a valid email address!");
    return false;
  }

  return true;
}

// Razorpay Payment + Save to DB

function handlePayment(e) {
  e.preventDefault();

  if (!validateForm()) return false;

  const form = document.getElementById("bookingForm");
  const price = document.getElementById("price").value;

  if (price <= 0) {
    alert("Please select a package");
    return false;
  }

  // Razorpay Options

  const options = {
    key: "rzp_test_REge0eBKuIICBL",
    amount: price * 100,
    currency: "INR",
    name: "Epic Journey",
    description: "Book Your Dream Adventure with Epic Journey",

    handler: function (response) {
      // Send data to PHP after payment success
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "PHP/book.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      const data = new URLSearchParams(new FormData(form));
      data.append("payment_id", response.razorpay_payment_id);
      data.append("status", "success");

      xhr.onload = function () {
        if (xhr.status === 200) {
          const res = JSON.parse(xhr.responseText);
          if (res.status === "success") {
            alert("Booking successful!");
            window.location.href = "../successful.html";
          } else {
            alert(res.message);
          }
        } else if (xhr.status === 401) {
          alert("Please login first!");
          window.location.href = "../login.html";
        } else {
          alert("Server error! Booking not saved.");
        }
      };

      xhr.send(data.toString());
    },

    modal: {
      ondismiss: function () {
        const form = document.getElementById("bookingForm");
        const data = new URLSearchParams(new FormData(form));
        data.append("status", "failed");

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "PHP/book.php", true);
        xhr.setRequestHeader(
          "Content-Type",
          "application/x-www-form-urlencoded"
        );
        xhr.send(data.toString());

        alert("Booking failed to save!");
      },
    },

    prefill: {
      name: form.name.value,
      email: form.email.value,
      contact: form.mobile.value,
    },
    theme: { color: "#3399cc" },
  };

  const rzp = new Razorpay(options);
  rzp.open();
  return false;
}

/*function updatePrice() {
  const val = document.getElementById("destination").value;
  const price = val.split("|")[1] || 0;
  document.getElementById("price").value = price;
}*/
