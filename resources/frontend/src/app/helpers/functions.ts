/**
 * Formats date in the correct format for date input field
 *
 * @param { string } dateString
 * @return string
 */
export function formatDate(dateString: string): string {
  const parts: string[] = dateString.split('-');
  return `${parts[2]}-${parts[1]}-${parts[0]}`;
}

/**
 * Joins an array of authors with a comma
 *
 * @param { any[] } authors
 * @return string
 */
export function extractAuthorNames(authors: any[]): string {
  const authorNames: any[] = authors.map(author => author.name);
  return authorNames.join(', ');
}

/**
 * Checks if event is in the future
 *
 * @param { any } date
 * @return boolean
 */
export function isEventInFuture(date: any): boolean {
  return new Date(date).getTime() > new Date().getTime();
}

/**
 * Creates a filter query based on the parameters of the search bar
 *
 * @param { string } keyword
 * @param { any } filter
 * @param { boolean } unpaginated
 * @return string
 */
export function getFilterQuery(keyword: string, filter: any, unpaginated: boolean = false): string {
  let keywordQuery: string = "";
  if (keyword !== "") {
    keywordQuery += "?keyword=" + keyword;
  }

  let filterQuery: string = "";
  if (filter !== null) {
    filterQuery += "?order=" + filter.order + "&field=" + filter.field;
  }

  let unpaginatedQuery: string = "";
  if (unpaginated) {
    unpaginatedQuery += "?unpaginated=true";
  }

  return keywordQuery + filterQuery + unpaginatedQuery;
}
