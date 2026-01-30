//university at glance js

document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector(".glance-stats");
  if (!track) return;

  // 🔒 MOBILE ONLY
  if (window.innerWidth > 767) return;

  // prevent multiple cloning
  if (track.dataset.cloned) return;
  track.dataset.cloned = "true";

  // clone once for seamless loop
  const clone = track.cloneNode(true);
  clone.setAttribute("aria-hidden", "true");
  track.appendChild(clone);

  let pos = 0;
  const speed = 0.35;

  function autoScroll() {
    pos += speed;
    track.scrollLeft = pos;

    if (pos >= track.scrollWidth / 2) {
      pos = 0;
    }

    requestAnimationFrame(autoScroll);
  }

  autoScroll();
});

//homepage vc section js

document.addEventListener('DOMContentLoaded', () => {
    const vcTrack = document.querySelector('.vc-slider-track');
    if (!vcTrack) return;
    const slides = Array.from(vcTrack.children);
    let idx = 0;
    const total = slides.length;
    let isPaused = false;

    function goTo(i) {
        vcTrack.style.transform = `translateX(${-i * 100}%)`;
    }

    const interval = 3500;
    let timer = setInterval(() => {
        if (!isPaused) {
            idx = (idx + 1) % total;
            goTo(idx);
        }
    }, interval);

    const slider = vcTrack.closest('.vc-slider');
    slider.addEventListener('mouseenter', () => {
        isPaused = true
    });
    slider.addEventListener('mouseleave', () => {
        isPaused = false
    });
});

//homepage slider section js
document.addEventListener("DOMContentLoaded", () => {

    const track = document.querySelector(".slider-track");
    let cards = Array.from(track.children);

    /* 🔁 Duplicate cards once for seamless loop */
    cards.forEach(card => {
        const clone = card.cloneNode(true);
        track.appendChild(clone);
    });

    let position = 0;
    let speed = 0.35; // 🔥 slow speed
    let isPaused = false;

    function animate() {
        if (!isPaused) {
            position -= speed;

            /* reset when half scrolled */
            if (Math.abs(position) >= track.scrollWidth / 2) {
                position = 0;
            }

            track.style.transform = `translateX(${position}px)`;
        }

        requestAnimationFrame(animate);
    }

    animate();

    /* ⏸ PAUSE ON HOVER */
    track.addEventListener("mouseenter", () => {
        isPaused = true;
    });

    track.addEventListener("mouseleave", () => {
        isPaused = false;
    });

});