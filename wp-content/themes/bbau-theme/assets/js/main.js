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


/* ================= VC SECTION SLIDER ================= */
document.addEventListener('DOMContentLoaded', () => {
  const vcTrack = document.querySelector('.vc-slider-track');
  if (!vcTrack) return;

  const origSlides = Array.from(vcTrack.children);
  if (origSlides.length < 2) return;

  /* Clone all slides for seamless loop */
  origSlides.forEach(slide => {
    const clone = slide.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    vcTrack.appendChild(clone);
  });

  const total = origSlides.length;
  let idx = 0;
  let isAnimating = false;
  const SPEED = 600;
  const PAUSE = 3500;

  function goTo(i, animate) {
    vcTrack.style.transition = animate ? `transform ${SPEED}ms ease` : 'none';
    vcTrack.style.transform = `translateX(${-i * 100}%)`;
  }

  vcTrack.addEventListener('transitionend', () => {
    isAnimating = false;
    /* Silently snap back when on cloned set */
    if (idx >= total) {
      idx = idx - total;
      goTo(idx, false);
    }
  });

  function next() {
    if (isAnimating) return;
    isAnimating = true;
    idx++;
    goTo(idx, true);
  }

  goTo(0, false);
  let timer = setInterval(next, PAUSE);

  const vcSlider = vcTrack.closest('.vc-slider');
  vcSlider.addEventListener('mouseenter', () => clearInterval(timer));
  vcSlider.addEventListener('mouseleave', () => { timer = setInterval(next, PAUSE); });
});


/* ================= HOMEPAGE SLIDER (MARQUEE) ================= */
document.addEventListener('DOMContentLoaded', () => {
  const track = document.querySelector('.slider-track');
  if (!track) return;

  /* Clone once for seamless loop */
  Array.from(track.children).forEach(card => {
    const clone = card.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    track.appendChild(clone);
  });

  let pos = 0;
  const speed = 0.35;
  let paused = false;
  let halfWidth = 0;

  function getHalf() {
    /* Half of total scrollWidth = one full original set width */
    halfWidth = track.scrollWidth / 2;
  }

  getHalf();
  window.addEventListener('resize', getHalf);

  function animate() {
    if (!paused) {
      pos -= speed;
      if (pos <= -halfWidth) pos = 0; /* Snap back invisibly */
      track.style.transform = `translateX(${pos}px)`;
    }
    requestAnimationFrame(animate);
  }

  animate();

  track.addEventListener('mouseenter', () => { paused = true; });
  track.addEventListener('mouseleave', () => { paused = false; });
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

    search.addEventListener("keyup", filterSpeeches);
    yearFilter.addEventListener("change", filterSpeeches);

});