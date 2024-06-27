document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('departmentForm');
    const departmentList = document.getElementById('departmentsList');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(form);
        const name = formData.get('name');
        if (name.trim() === '') {
            alert('Please enter a department name.');
            return;
        }
        addDepartment(name);
        form.reset();
    });

    function addDepartment(name) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_department.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    fetchDepartments();
                } else {
                    console.error('Failed to add department.');
                }
            }
        };
        xhr.send('name=' + encodeURIComponent(name));
    }

    function fetchDepartments() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_departments.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const departments = JSON.parse(xhr.responseText);
                    displayDepartments(departments);
                } else {
                    console.error('Failed to fetch departments.');
                }
            }
        };
        xhr.send();
    }

    function displayDepartments(departments) {
        departmentList.innerHTML = '';
        departments.forEach(function(department) {
            const departmentItem = document.createElement('div');
            departmentItem.classList.add('department');
            departmentItem.textContent = department.name;
            departmentList.appendChild(departmentItem);
        });
    }

    fetchDepartments();
});
