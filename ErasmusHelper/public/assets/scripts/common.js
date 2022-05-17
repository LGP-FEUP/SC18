
/**
 * AJAX handling
 *
 * @param url
 * @param method
 * @param data
 * @returns {Promise<any>}
 */
function ajx(url, method, data) {
    return new Promise(function (resolve, reject) {
        if (typeof (method) === "undefined") {
            method = "GET";
        }
        if (typeof (data) === "undefined") {
            data = "";
        }

        if (!url.includes("source=")) {
            url += (url.includes('?') ? '&' : '?') + "source=ajax";
        }

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    resolve(xhr.responseText, xhr);
                } else {
                    reject(xhr.responseText, xhr);
                }
            }
        };

        xhr.open(method, url, true);

        if (method === "POST" && !(data instanceof FormData)) {
            if (typeof data === 'object') {
                const form_data = new FormData();
                for (let k in data) {
                    if (data.hasOwnProperty(k)) {
                        if (typeof data[k] === 'object') {
                            data[k] = JSON.stringify(data[k]);
                        }
                        form_data.append(k, data[k]);
                    }
                }
                data = form_data;
            } else {
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            }
        }

        xhr.send(data);
    });
}
