import { AbstractControl, ValidatorFn } from '@angular/forms';

// Custom validator function
export function numberValidator(): ValidatorFn {
  return (control: AbstractControl): { [key: string]: any } | null => {
    const value = control.value;

    if (value !== null && isNaN(value)) {
      return { 'number': { value: value } };
    }

    return null;
  };
}
