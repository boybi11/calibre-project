export function moreChar (text = '', length = 100, ellipsis = '...') {
    if(text.length > length) {
        text = text.substr(0, length) + ellipsis;
    }

     return text;
}