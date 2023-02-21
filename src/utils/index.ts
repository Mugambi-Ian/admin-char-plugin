import { __ ,setLocaleData} from '@wordpress/i18n';

const domain = "admin-chart";


// @ts-expect-error
setLocaleData(window.locale.data, domain);
export const translate = (x: string) => {
  const result = __(x, domain);
  return result;
};
