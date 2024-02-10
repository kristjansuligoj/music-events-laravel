export function formatDate(dateString: string): string {
  const parts = dateString.split('-');
  return `${parts[2]}-${parts[1]}-${parts[0]}`;
}

export function extractAuthorNames(authors: any[]): string {
  const authorNames = authors.map(author => author.name);
  return authorNames.join(', ');
}

export function isDateAfterToday(date: any) {
  return new Date(new Date(date).toDateString()) > new Date(new Date().toDateString());
}
