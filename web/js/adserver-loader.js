(function () {
    var urlBase = 'http://adserver.test/advertisment',
        containers = document.querySelectorAll('.adserver-container');

    for (var i = 0; i < containers.length; i++) {
        var requestPath = [urlBase];

        if (containers[i].hasAttribute('data-contentunit')) {
            requestPath.push('contentunit');
            requestPath.push(containers[i].getAttribute('data-contentunit'));
        }

        if (containers[i].hasAttribute('data-campaign')) {
            requestPath.push('campaign');
            requestPath.push(containers[i].getAttribute('data-campaign'));
        }

        var xhttp = new XMLHttpRequest();

        xhttp.open('GET', requestPath.join('/') + '/', true);
        xhttp.send();

        (function (element, xhttp) {
            xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    var banner = JSON.parse(xhttp.responseText);

                    if (banner.clickurl && banner.caption && banner.name) {
                        element.innerHTML =
                            '<a target="_blank" href="' + banner.clickurl + '" alt="' + banner.name + '" style="width: 100%; height: 100%; display: inline-block">' +
                                ((banner.imageUrl) ? '<img src="' + banner.imageUrl + '">' : '') +
                                '<span style="display: inline-block; width: 100%;">' + banner.caption + '</span>'
                            '</a>';


                        element.style.width = banner.width + 'px';
                        element.style.height = banner.height + 'px';
                        element.style.border = '1px solid black';
                        element.style.textAlign = 'center';
                    }
                }
            }
        })(containers[i], xhttp);
    }
})();