let items1 = document.querySelectorAll('#recipeCarousel1 .carousel-item');
let items2 = document.querySelectorAll('#recipeCarousel2 .carousel-item');
let items3 = document.querySelectorAll('#recipeCarousel3 .carousel-item');

function handleSlider(items) {
    items.forEach((el) => {
        const minPerSlide = 4;
        let next = el.nextElementSibling;
        for (var i = 1; i < minPerSlide; i++) {
            if (!next) {
                // Wrap carousel by using first child
                next = items[0];
            }
            let cloneChild = next.cloneNode(true);
            el.appendChild(cloneChild.children[0]);
            next = next.nextElementSibling;
        }
    });
}

// Call the function for each slider
handleSlider(items1);
handleSlider(items2);
handleSlider(items3);
