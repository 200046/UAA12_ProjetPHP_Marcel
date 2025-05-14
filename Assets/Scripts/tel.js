document.addEventListener("click", function(event) {
    // Fermer toutes les boîtes ouvertes sauf celle qu'on vient de cliquer
    const phoneWrappers = document.querySelectorAll(".phone-wrapper");

    phoneWrappers.forEach(wrapper => {
        const button = wrapper.querySelector("button");
        const infoBox = wrapper.querySelector(".phone-info");

        if (button.contains(event.target)) {
            // Toggle si on clique sur le bouton
            const isVisible = infoBox.style.display === "block";
            document.querySelectorAll(".phone-info").forEach(box => box.style.display = "none");
            infoBox.style.display = isVisible ? "none" : "block";
        } else if (!wrapper.contains(event.target)) {
            // Clic à l'extérieur → fermer
            infoBox.style.display = "none";
        }
    });
});
