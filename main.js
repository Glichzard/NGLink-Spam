const myButton = document.getElementById("sendButton")
myButton.addEventListener("click", (e) => {
    myButton.innerHTML += `
        <div class="spinner-border spinner-border-sm" role="status">
            <span class="visually-hidden">Sending...</span>
        </div>
    `
    myButton.disabled = true

    const formData = new FormData()
    formData.append("link", document.getElementById("ngLink").value)
    formData.append("message", document.getElementById("ngMessage").value)
    formData.append("numberOfMessages", document.getElementById("ngCount").value)

    e.preventDefault()
    $.ajax({
        url:   './api.php',
        type:  'post',
        processData: false,
        contentType: false,
        data: formData,
        success:  function (response) {
            myButton.innerHTML = "Empezar spam"
            myButton.disabled = false

            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.onmouseenter = Swal.stopTimer;
                  toast.onmouseleave = Swal.resumeTimer;
                }
              });
              Toast.fire({
                icon: "success",
                title: `Se han enviado correctamente ${response} de ${document.getElementById("ngCount").value} mensajes`
              });
        }
    })
})