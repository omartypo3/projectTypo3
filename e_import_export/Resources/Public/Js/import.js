document.addEventListener("DOMContentLoaded", () => {
  const dropdown = document.getElementById("geoDropdown");
  const btn = document.getElementById("geoDropdownBtn");

  const updateButtonText = () => {
    const activeItem = dropdown.querySelector("li.active a");
    if (activeItem) {
      btn.textContent = activeItem.textContent.trim();
    } else if (dropdown.querySelector("li a")) {
      // If no active item but items exist, use the first one
      const firstItem = dropdown.querySelector("li a");
      btn.textContent = firstItem.textContent.trim();
      firstItem.parentElement.classList.add("active");
    }
  };

  updateButtonText();

  btn.addEventListener("click", (e) => {
    e.stopPropagation();
    dropdown.classList.toggle("open");
  });

  document.addEventListener("click", () => {
    dropdown.classList.remove("open");
  });

  const items = dropdown.querySelectorAll("ul li a");
  items.forEach((item) => {
    item.addEventListener("click", (e) => {
      items.forEach((i) => i.parentElement.classList.remove("active"));
      item.parentElement.classList.add("active");

      btn.textContent = item.textContent.trim();

      dropdown.classList.remove("open");
    });
  });
});
