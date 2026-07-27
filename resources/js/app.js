/*
|--------------------------------------------------------------------------
| Global Supply Chain Risk Intelligence
|--------------------------------------------------------------------------
| Main JavaScript file
|--------------------------------------------------------------------------
*/

console.log(
    'Global Supply Chain Risk Intelligence is running.'
);


/*
|--------------------------------------------------------------------------
| Mobile Sidebar
|--------------------------------------------------------------------------
*/

window.toggleSidebar = function () {

    const sidebar =
        document.querySelector('.sidebar');

    if (!sidebar) {
        return;
    }

    sidebar.classList.toggle(
        'sidebar-open'
    );

};


/*
|--------------------------------------------------------------------------
| Close Mobile Sidebar
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'click',
    function (event) {

        const sidebar =
            document.querySelector('.sidebar');

        const button =
            document.querySelector(
                '.mobile-menu-button'
            );

        if (
            window.innerWidth <= 768 &&
            sidebar &&
            button &&
            !sidebar.contains(event.target) &&
            !button.contains(event.target)
        ) {

            sidebar.classList.remove(
                'sidebar-open'
            );

        }

    }
);