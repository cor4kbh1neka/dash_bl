function adjustElementSize() {
    // properti width
    const allWidth = document.querySelectorAll('*');
    allWidth.forEach((element) => {
        const classes = element.classList;
        classes.forEach((className) => {
            if (className.startsWith('wdi-') && !element.classList.contains('footer')) {
                const widthValue = className.replace('wdi-', '');
                if (widthValue.startsWith('px-')) {
                    const pixelValue = widthValue.replace('px-', '');
                    element.style.width = pixelValue + 'px';
                } else {
                    element.style.width = widthValue + '%';
                }
            }
            if (className.startsWith('gd-')) {
                const gridColumnValue = className.replace('gd-', '');
                const gridColumnTemplate = `repeat(${gridColumnValue}, 1fr)`;
                element.style.gridTemplateColumns = gridColumnTemplate;
            }
        });
    });

    // properti height
    const allHeight = document.querySelectorAll('*');
    allHeight.forEach((element) => {
        const classes = element.classList;
        classes.forEach((className) => {
            if (className.startsWith('hgi-') && !element.classList.contains('footer')) {
                const heightValue = className.replace('hgi-', '');
                if (heightValue.startsWith('px-')) {
                    const pixelValue = heightValue.replace('px-', '');
                    element.style.height = pixelValue + 'px';
                } else {
                    element.style.height = heightValue + '%';
                }
            }
        });
    });
}
