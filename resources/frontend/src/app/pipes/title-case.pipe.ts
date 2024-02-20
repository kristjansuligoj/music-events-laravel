import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  standalone: true,
  name: 'titleCase'
})
export class TitleCasePipe implements PipeTransform {
  transform(value: string): string {
    if (!value) return value;

    return value
      .replace(/([A-Z])/g, ' $1') // Insert space before capital letters
      .toLowerCase()
      .replace(/^./, (firstLetter) => firstLetter.toUpperCase()); // Capitalize first letter
  }
}
