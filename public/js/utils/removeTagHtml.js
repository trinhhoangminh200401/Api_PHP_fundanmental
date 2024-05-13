export const clearHTMLTags = (strToSanitize) => {
    return strToSanitize.replace(/(<([^>]+)>)/gi, '');
}