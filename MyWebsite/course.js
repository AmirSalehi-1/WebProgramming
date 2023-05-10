document.addEventListener("DOMContentLoaded", () => {
  const searchButton = document.getElementById("search-button");
  const searchInput = document.getElementById("search-input");
  const courseList = document.querySelector(".course-list");
 

  searchButton.addEventListener("click", () => {
    const searchTerm = searchInput.value.toLowerCase();
    const courses = courseList.querySelectorAll(".course");

    courses.forEach((course) => {
      const courseTitle = course.querySelector("h2").textContent.toLowerCase();
      if (courseTitle.includes(searchTerm)) {
        course.style.display = "block";
      } else {
        course.style.display = "none";
      }
    });
  });

  // get the level select element and course list element
  const levelSelect = document.getElementById("level-select");
  const courseList2 = document.querySelector(".course-list");

  // add an event listener to the filter button
  document.getElementById("filter-button").addEventListener("click", () => {
    // get the selected level
    const selectedLevel = levelSelect.value;

    // loop through each course element and show or hide based on the selected level
    Array.from(courseList.children).forEach((courseRow) => {
      Array.from(courseRow.children).forEach((course) => {
        const courseLevel = course
          .querySelector(".level")
          .textContent.toLowerCase();
        if (selectedLevel === "all" || courseLevel === selectedLevel) {
          course.style.display = "block";
        } else {
          course.style.display = "none";
        }
      });
    });
  });

  function sortByLevelAsc() {
    const courses = document.querySelectorAll(".course");
    
    courses.forEach((course) => course.remove());

    Array.from(courses)
      .sort((a, b) =>
        a
          .querySelector(".level")
          .textContent.localeCompare(b.querySelector(".level").textContent)
      )
      .forEach((course) =>
        document.querySelector(".course-list").appendChild(course)
      );
  }

  function sortByLevelDesc() {
    const courses = document.querySelectorAll(".course");
    courses.forEach((course) => course.remove());
    Array.from(courses)
      .sort((a, b) =>
        b
          .querySelector(".level")
          .textContent.localeCompare(a.querySelector(".level").textContent)
      )
      .forEach((course) =>
        document.querySelector(".course-list").appendChild(course)
      );
  }

  document.querySelector("#sort-button").addEventListener("click", () => {
    const sortSelect = document.querySelector("#sort-select");
    if (sortSelect.value === "asc") {
      sortByLevelAsc();
    } else {
      sortByLevelDesc();
    }
  });
});
function myFunction2() {
  const message = "My Email is: lavie.salehi@gmail.com ";
  alert(
    message.replace("This page says", "Please feel free to contact me 24/7")
  );
}
