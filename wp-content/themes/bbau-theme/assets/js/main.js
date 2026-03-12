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

document.addEventListener("DOMContentLoaded", () => {
  const counters = document.querySelectorAll(".count");
  let started = false;

  const animateCounters = () => {
    counters.forEach(counter => {
      const target = parseInt(counter.dataset.target, 10);
      const suffix = counter.dataset.suffix || "";
      let current = 0;

      const duration = 1600; // ms (professional speed)
      const startTime = performance.now();

      const update = (now) => {
        const progress = Math.min((now - startTime) / duration, 1);
        const value = Math.floor(progress * target);

        counter.textContent = value.toLocaleString() + suffix;

        if (progress < 1) {
          requestAnimationFrame(update);
        } else {
          counter.textContent = target.toLocaleString() + suffix;
        }
      };

      requestAnimationFrame(update);
    });
  };

  const observer = new IntersectionObserver(entries => {
    if (entries[0].isIntersecting && !started) {
      started = true;
      animateCounters();
    }
  }, { threshold: 0.4 });

  observer.observe(document.querySelector(".glance-section"));
});


//inner menu js

jQuery(document).ready(function($) {

    /* horizontal scroll for active item */

    var activeItem = $('.common-menu-link.active');

    if (activeItem.length) {

        var container = $('.common-menu-nav');

        container.animate({
            scrollLeft: activeItem.position().left - 100
        }, 300);

    }

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


//vc speech search js

document.addEventListener("DOMContentLoaded", function() {

    const search = document.getElementById("speechSearch");
    const yearFilter = document.getElementById("yearFilter");
    const cards = document.querySelectorAll(".speech-card");

    function filterSpeeches() {

        let searchValue = search.value.toLowerCase();
        let yearValue = yearFilter.value;

        cards.forEach(card => {

            let title = card.querySelector("h3").textContent.toLowerCase();
            let year = card.dataset.year;

            let matchSearch = title.includes(searchValue);
            let matchYear = yearValue === "" || year === yearValue;

            if (matchSearch && matchYear) {
                card.style.display = "flex";
            } else {
                card.style.display = "none";
            }

        });

    }

    if (search) {
      search.addEventListener("keyup", filterSpeeches);
  }
  
  if (yearFilter) {
      yearFilter.addEventListener("change", filterSpeeches);
  }
});

