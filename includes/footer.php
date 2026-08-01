<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

function copyWebsiteLink(button){

    const input = document.getElementById("websiteLink");

    navigator.clipboard.writeText(input.value);

    const oldText = button.innerHTML;

    button.innerHTML =
    '<i class="bi bi-check-circle-fill"></i> Copied';

    button.classList.remove("btn-success");
    button.classList.add("btn-primary");

    setTimeout(function(){

        button.innerHTML = oldText;

        button.classList.remove("btn-primary");
        button.classList.add("btn-success");

    },2000);

}

</script>

</body>
</html>