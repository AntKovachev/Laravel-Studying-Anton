document.addEventListener('DOMContentLoaded', function () {
    var openDropdown = null;

    // Add event listener to the document for username links
    document.addEventListener('click', function (event) {
        // Find the closest ancestor with an ID starting with 'userRow'
        var userRow = event.target.closest('[id^="userRow"]');

        if (userRow) {
            // Get the user ID from the element's ID
            var userId = userRow.id.replace('userRow', '');

            // Close the previously opened dropdown, if any
            if (openDropdown) {
                openDropdown.classList.add('hidden');
            }

            // Reset the openDropdown variable
            openDropdown = null;

            // Toggle the visibility of the dropdown content
            var dropdownContent = document.getElementById('dropdownContent' + userId);
            dropdownContent.classList.toggle('hidden');
            openDropdown = dropdownContent;

            // Remove gray background from all rows
            document.querySelectorAll('.bg-gray-300').forEach(function (row) {
                row.classList.remove('bg-gray-300');
            });

            // Add gray background to the current user row
            userRow.classList.toggle('bg-gray-300');
        } else {
            // Clicked outside of any user row, close all dropdowns
            document.querySelectorAll('.bg-gray-300').forEach(function (row) {
                row.classList.remove('bg-gray-300');
            });

            openDropdown?.classList.add('hidden');
            openDropdown = null;
        }
    });
});