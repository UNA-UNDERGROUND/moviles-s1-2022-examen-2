export const NUMBERS = RegExp(/^[0-9]{9}$/);
export const AGE = RegExp(/^[0-9]*$/);
export const PHONE = RegExp(/^[0-9]{8}$/);
export const STRINGS = RegExp(/^[a-zA-ZÀ-ÿ\s]*$/);
export const EMAIL = RegExp(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/);
export const ADDRESS = RegExp(/^[a-zA-ZÀ-ÿ0-9\s,.]*$/);