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

            if (elEnd < winStart) {
                continue;
            }

            if (elStart >= winEnd) {
                continue
            }

            updateNavStyle(id.value);
            return;
        }
    }
}

const modalState = [];

const showModal = (identifier) => {
    const element = document.getElementById(identifier);
    element.style.display = "flex";
    modalState.push(element);
}

const closeModal = (identifier) => {
    const element = document.getElementById(identifier);
    element.style.display = "none";
    modalState.pop();
}

const closeModalIfOutOfSpace = event => {
    if (!modalState.length) {
        return;
    }

    if (event.target.nodeName === 'BUTTON' && event.type === 'click') {
        return;
    }

    const lastModal = modalState[modalState.length - 1];
    const children = lastModal.children;


    const offsetX = event.clientX;
    const offsetY = event.clientY;

    for (const child of children) {
        const childWith = child.offsetWidth;
        const childHeight = child.offsetHeight;
        const childStartX = child.offsetLeft;
        const childStartY = child.offsetTop;
        const childEndX = childStartX + childWith;
        const childEndY = childStartY + childHeight;

        if (offsetY >= childStartY && offsetY <= childEndY && offsetX >= childStartX && offsetX <= childEndX) {
            return;
        }
    }

    lastModal.style.display = 'none';
    modalState.pop();
}

const toClipboard = (identifier) => {
    const element = document.getElementById(identifier);
    element.style.backgroundColor = 'var(--primary)';
    element.style.color = 'var(--bc-content)';
    navigator.clipboard.writeText(element.innerText);
    setTimeout(() => {
        element.style.backgroundColor = 'var(--code-color)';
        element.style.color = 'var(--primary)';
    }, 1500)
}

window.addEventListener('scroll', updateNav);
window.addEventListener('resize', updateNav);
window.addEventListener('mousedown', closeModalIfOutOfSpace);
window.addEventListener('keydown', e => e.key === 'Escape' && closeModalIfOutOfSpace(e));

updateNav();