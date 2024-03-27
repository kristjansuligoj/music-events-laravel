import { AbstractControl, ValidatorFn } from '@angular/forms';

export function atLeastOneCheckboxClickedValidator(): ValidatorFn {
  return (control: AbstractControl): { [key: string]: boolean } | null => {
    const selectedCheckboxes = (control as any).value.some((isChecked: boolean) => isChecked);
    return selectedCheckboxes ? null : { noCheckboxSelected: true };
  };
}
