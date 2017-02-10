
var urlGeneral = "./resources/";
var urlNews = urlGeneral + "news.json";
var urlPublications = urlGeneral + "publications.json";

function loadNews(obj, max) {
    $.get(urlNews, function (data) {
        var details = false;
        if (max == 0) {
            max = data.length;
            details = true;
        } else if (max > data.length) {
            max = data.length;
        }
        for (var i = 0; i < max; i++) {
            var item = data[i];
            appendNewsItem(item, obj, details);
        }
    });
}

function appendNewsItem(item, obj, includeHTML) {
    obj.append("<a class=\"newsHeader\" href=\"./news.html?id=" + item.id + "\"><b>" + item.title + "</b></a>");
    if (includeHTML) {
        obj.append("<p><b>" + item.summary + "</b></p>" + item.html);
    } else {
        obj.append("<p>" + item.summary + "</p>");
    }
    obj.append("<p class=\"date\">" + item.date + "</p>");
}

function appendPublicationsItem(item, obj, includeHTML) {
    obj.append("<a class=\"newsHeader\" href=\"./news.html?id=" + item.id + "\"><b>" + item.title + "</b></a>");
    if (includeHTML) {
        obj.append("<p><b>" + item.summary + "</b></p>" + item.html);
    } else {
        obj.append("<p>" + item.summary + "</p>");
    }
    obj.append("<p class=\"date\">" + item.date + "</p>");
}

function loadPublications(obj, max) {
    $.get(urlPublications, function (data) {
        if (!data.length) {
            obj.append("<p>No publications so far.</p>");
        }
        var details = false;
        if (max == 0) {
            max = data.length;
            details = true;
        } else if (max > data.length) {
            max = data.length;
        }
        for (var i = 0; i < max; i++) {
            var item = data[i];
            appendPublicationsItem(item, obj, details);
        }
    });
}

function loadData(publications, news, max) {
    loadNews(news, max);
    loadPublications(publications, max);
}

