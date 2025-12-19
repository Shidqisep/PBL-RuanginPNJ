// Smooth open/close accordion using max-height animation
function toggleAccordion(id) {
    const content = document.getElementById(`content-${id}`);
    const icon = document.getElementById(`icon-${id}`);

    if (!content) return;

    // Ensure transition styles
    content.style.overflow = 'hidden';
    content.style.transition = 'max-height 300ms ease, opacity 200ms ease';

    const isHidden = content.classList.contains('hidden');

    // Close other open accordions with animation
    document.querySelectorAll('.accordion-content').forEach(item => {
        if (item === content) return;
        if (!item.classList.contains('hidden')) {
            const otherIcon = document.getElementById(item.id.replace('content-', 'icon-'));
            closeAccordion(item, otherIcon);
        }
    });

    if (isHidden) {
        openAccordion(content, icon);
    } else {
        closeAccordion(content, icon);
    }
}

function openAccordion(content, icon) {
    // Remove hidden so element becomes measurable
    content.classList.remove('hidden');
    // Start from zero height
    content.style.maxHeight = '0px';
    content.style.opacity = '0';
    // Force reflow
    // eslint-disable-next-line no-unused-expressions
    content.offsetHeight;
    // Animate to full height
    content.style.maxHeight = content.scrollHeight + 'px';
    content.style.opacity = '1';
    if (icon) icon.classList.add('rotate-180');

    // After transition, clear maxHeight to allow internal changes
    const cleanup = () => {
        content.style.maxHeight = '';
        content.removeEventListener('transitionend', cleanup);
    };
    content.addEventListener('transitionend', cleanup);
}

function closeAccordion(content, icon) {
    // Set explicit height then animate to 0
    content.style.maxHeight = content.scrollHeight + 'px';
    // Force reflow
    // eslint-disable-next-line no-unused-expressions
    content.offsetHeight;
    content.style.maxHeight = '0px';
    content.style.opacity = '0';
    if (icon) icon.classList.remove('rotate-180');

    const onEnd = () => {
        content.classList.add('hidden');
        // reset styles
        content.style.maxHeight = '';
        content.style.opacity = '';
        content.removeEventListener('transitionend', onEnd);
    };
    content.addEventListener('transitionend', onEnd);
}

// Auto-scroll to the clicked accordion (keeps previous behavior)
document.querySelectorAll('[onclick^="toggleAccordion"]').forEach(button => {
    button.addEventListener('click', function() {
        setTimeout(() => {
            this.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 350);
    });
});
