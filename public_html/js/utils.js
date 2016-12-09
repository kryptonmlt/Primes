
var urlGeneral = "http://130.209.244.160:8028/content/";
var urlContentTypes = urlGeneral + "types/";
var urlNews = urlGeneral + "news/";
var urlPublications = urlGeneral + "publications/";
var urlLatestNews = urlNews + "latest/3";
var urlLatestPublications = urlPublications + "latest/3";

Date.prototype.customFormat = function (formatString) {
    var YYYY, YY, MMMM, MMM, MM, M, DDDD, DDD, DD, D, hhhh, hhh, hh, h, mm, m, ss, s, ampm, AMPM, dMod, th;
    var dateObject = this;
    YY = ((YYYY = dateObject.getFullYear()) + "").slice(-2);
    MM = (M = dateObject.getMonth() + 1) < 10 ? ('0' + M) : M;
    MMM = (MMMM = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"][M - 1]).substring(0, 3);
    DD = (D = dateObject.getDate()) < 10 ? ('0' + D) : D;
    DDD = (DDDD = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"][dateObject.getDay()]).substring(0, 3);
    th = (D >= 10 && D <= 20) ? 'th' : ((dMod = D % 10) == 1) ? 'st' : (dMod == 2) ? 'nd' : (dMod == 3) ? 'rd' : 'th';
    formatString = formatString.replace("#YYYY#", YYYY).replace("#YY#", YY).replace("#MMMM#", MMMM).replace("#MMM#", MMM).replace("#MM#", MM).replace("#M#", M).replace("#DDDD#", DDDD).replace("#DDD#", DDD).replace("#DD#", DD).replace("#D#", D).replace("#th#", th);

    h = (hhh = dateObject.getHours());
    if (h == 0)
        h = 24;
    if (h > 12)
        h -= 12;
    hh = h < 10 ? ('0' + h) : h;
    hhhh = hhh < 10 ? ('0' + hhh) : hhh;
    AMPM = (ampm = hhh < 12 ? 'am' : 'pm').toUpperCase();
    mm = (m = dateObject.getMinutes()) < 10 ? ('0' + m) : m;
    ss = (s = dateObject.getSeconds()) < 10 ? ('0' + s) : s;
    return formatString.replace("#hhhh#", hhhh).replace("#hhh#", hhh).replace("#hh#", hh).replace("#h#", h).replace("#mm#", mm).replace("#m#", m).replace("#ss#", ss).replace("#s#", s).replace("#ampm#", ampm).replace("#AMPM#", AMPM);
}

function loadLatestNews(obj) {

    $.get(urlLatestNews, function (data) {
        for (var i = 0; i < data.length; i++) {
            var item = data[i];
            appendNewsItem(item, obj, false);
        }
    });
}

function loadAllNews(obj) {

    $.get(urlNews, function (data) {
        for (var i = 0; i < data.length; i++) {
            var item = data[i];
            appendNewsItem(item, obj, true);
        }
    });
}

function appendNewsItem(item, obj, includeHTML) {
    obj.append("<a class=\"newsHeader\" href=\"./news.html?id=" + item.id + "\"><b>" + item.title + "</b></a>");
    if (includeHTML) {
        obj.append("<p><b>" + item.summary + "</b></p>");
        obj.append(item.html);
    } else {
        obj.append("<p>" + item.summary + "</p>");
    }
    var date = new Date(item.date);
    obj.append("<p class=\"date\">" + date.customFormat("#D#/#M#/#YYYY#") + "</p>");
}

function appendPublicationsItem(item, obj, includeHTML) {
    obj.append("<a class=\"newsHeader\" href=\"./news.html?id=" + item.id + "\"><b>" + item.title + "</b></a>");
    if (includeHTML) {
        obj.append("<p><b>" + item.summary + "</b></p>");
        obj.append(item.html);
    } else {
        obj.append("<p>" + item.summary + "</p>");
    }
    var date = new Date(item.date);
    obj.append("<p>" + date.customFormat("#D#/#M#/#YYYY#") + "</p>");
}

function loadAllPublications(obj) {

    $.get(urlPublications, function (data) {
        if (!data.length) {
            obj.append("<p>No Publications so far.</p>");
        }
        for (var i = 0; i < data.length; i++) {
            var item = data[i];
            appendPublicationsItem(item, obj, true);
        }
    });
}

function loadLatestPublications(obj) {

    $.get(urlLatestPublications, function (data) {
        if (!data.length) {
            obj.append("<p>No Publications so far.</p>");
        }
        for (var i = 0; i < data.length; i++) {
            var item = data[i];
            appendPublicationsItem(item, obj, false);
        }
    });
}

function loadLatest(publications, news) {
    loadLatestNews(news);
    loadLatestPublications(publications);
}

