/**
 * Formats date in the correct format for date input field
 *
 * @param dateString
 */
export function formatDate(dateString: string): string {
  const parts = dateString.split('-');
  return `${parts[2]}-${parts[1]}-${parts[0]}`;
}

/**
 * Joins an array of authors with a comma
 *
 * @param authors
 */
export function extractAuthorNames(authors: any[]): string {
  const authorNames = authors.map(author => author.name);
  return authorNames.join(', ');
}

/**
 * Checks if event is in the future
 *
 * @param date
 * @return boolean
 */
export function isEventInFuture(date: any): boolean {
  return new Date(date).getTime() > new Date().getTime();
}

/**
 * Creates a filter query based on the parameters of the search bar
 *
 * @param keyword
 * @param filter
 */
export function getFilterQuery(keyword: string, filter: any) {
  let keywordQuery = "";
  if (keyword !== "") {
    keywordQuery += "?keyword=" + keyword;
  }

  let filterQuery = "";
  if (filter !== null) {
    filterQuery += "?order=" + filter.order + "&field=" + filter.field;
  }

  return keywordQuery + filterQuery;
}
