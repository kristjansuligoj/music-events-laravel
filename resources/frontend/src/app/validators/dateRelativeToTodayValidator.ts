import { AbstractControl, ValidatorFn } from '@angular/forms';

export function dateRelativeToTodayValidator(relativeTo: 'before' | 'after'): ValidatorFn {
  return (control: AbstractControl): { [key: string]: any } | null => {
    const selectedDate = new Date(control.value);
    const today = new Date();

    if (relativeTo === 'before') {
      if (selectedDate.getTime() >= today.getTime()) {
        return { 'dateBeforeToday': { value: control.value } };
      }
    } else if (relativeTo === 'after') {
      if (selectedDate.getTime() <= today.getTime()) {
        return { 'dateAfterToday': { value: control.value } };
      }
    }

    return null;
  };
}
