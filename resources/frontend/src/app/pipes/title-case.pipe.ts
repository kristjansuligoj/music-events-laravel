import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  standalone: true,
  name: 'titleCase'
})
export class TitleCasePipe implements PipeTransform {
  /**
   * This pipe transforms camel case strings to spaced out strings, and capitalizes the first letter
   * Example:
   * camelCaseString -> Camel case string
   *
   * @param { string } value
   * @return string
   */
  transform(value: string): string {
    if (!value) return value;

    return value
      .replace(/([A-Z])/g, ' $1') // Insert space before capital letters
      .toLowerCase()
      .replace(/^./, (firstLetter) => firstLetter.toUpperCase()); // Capitalize first letter
  }
}
