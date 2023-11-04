import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    
    let reportViewStatus = document.getElementById('reportViewStatus');

    reportViewStatus.addEventListener('change', function(e) {
        e.preventDefault();
        let reportViewStatus = this.value;
        let url = new URL(reportsUrl);
        url.searchParams.append('status', reportViewStatus);

        fetch(url, {
            method: 'GET',
            headers: {'X-Requested-With': 'XMLHttpRequest',},
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) throw new Error("Something went wrong.");
            return response.text();
        })
        .then(html => {
            document.querySelector('#reportstable tbody').innerHTML = html;
        })
        .catch(error => {
            console.error("Something went wrong with the fetch request.");
        });
    });
});