const elements = document.querySelectorAll("main *")

const updateNavStyle = (identifier) => {
    const link = document.querySelector(`a[href="#${identifier}"]`);

    if (!link) {
        return false;
    }

    const old = document.querySelectorAll(`a[href]`);
    old.forEach(el => el.parentElement.classList.remove("link-selected"))

    link.parentElement.classList.add("link-selected");

    return true;
}

const updateNav = () => {
    const winStart = window.scrollY;
    const winEnd = winStart + window.innerWidth

    for (const el of elements) {
        const attributes = el.attributes;
        const id = attributes.getNamedItem("id");

        if (id) {
            const elStart = el.offsetTop;
            const elEnd = el.offsetTop + el.offsetHeight;

            if (elEnd < winStart){
                continue;
            }

            if (elStart >= winEnd){
                continue
            }

            updateNavStyle(id.value);
            return;
        }
    }
}

window.addEventListener('scroll', updateNav);
window.addEventListener('resize', updateNav);

updateNav();