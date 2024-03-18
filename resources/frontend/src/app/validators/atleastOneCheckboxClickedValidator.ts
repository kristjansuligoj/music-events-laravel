import { AbstractControl, ValidatorFn } from '@angular/forms';

export function atLeastOneCheckedValidator(): ValidatorFn {
  return (control: AbstractControl): { [key: string]: any } | null => {
    const selectedOptions = control.value as boolean[];
    if (selectedOptions && selectedOptions.length > 0 && selectedOptions.some(option => option)) {
      return null; // At least one option is selected, validation passes
    } else {
      return { atLeastOneChecked: true }; // Validation fails
    }
  };
}
