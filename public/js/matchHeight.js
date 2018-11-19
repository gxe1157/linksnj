function matchHeight (element, amt) {
    if (!element) return;
    var checkAmt = 0;
    var maxHeightQuery = 0;

    // run on an interval
    var interval = setInterval(function () {
        var elements = document.querySelectorAll(element);

        checkAmt++;

        for (e of elements) {
            if(e.offsetHeight > maxHeightQuery) {
                maxHeightQuery = e.offsetHeight;
            }
        }
        for (e of elements) {
            e.style.height = maxHeightQuery+"px";
        }

        if (checkAmt >= amt) {
            clearInterval(interval);
        }
    }, 1250);
}

