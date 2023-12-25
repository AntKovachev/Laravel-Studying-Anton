document.addEventListener('DOMContentLoaded', function () {
    var openDropdown = null;

    document.addEventListener('click', function (event) {
        var friendRow = event.target.closest('[id^="friendRow"]');
        
        if (friendRow) {
            var friendId = friendRow.id.replace('friendRow', '');

            if (openDropdown) {
                openDropdown.classList.add('hidden');
            }

            openDropdown = null;

            var dropdownContent = document.getElementById('dropdownContent' + friendId);
            dropdownContent.classList.toggle('hidden');
            openDropdown = dropdownContent;

            document.querySelectorAll('.bg-gray-300').forEach(function (row) {
                row.classList.remove('bg-gray-300');
            });

            friendRow.classList.toggle('bg-gray-300');
        } else {
            document.querySelectorAll('.bg-gray-300').forEach(function (row) {
                row.classList.remove('bg-gray-300');
            });

            openDropdown?.classList.add('hidden');
            openDropdown = null;
        }
    });
});
