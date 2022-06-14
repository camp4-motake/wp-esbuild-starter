/**
 * WebP support test
 * https://developers.google.com/speed/webp/faq#in_your_own_javascript
 */

type Result = {
  result: boolean;
  feature: string;
  img: HTMLImageElement;
};

const kTestImages: { [index: string]: string } = {
  lossy: 'UklGRiIAAABXRUJQVlA4IBYAAAAwAQCdASoBAAEADsD+JaQAA3AAAAAA',
  lossless: 'UklGRhoAAABXRUJQVlA4TA0AAAAvAAAAEAcQERGIiP4HAA==',
  alpha:
    'UklGRkoAAABXRUJQVlA4WAoAAAAQAAAAAAAAAAAAQUxQSAwAAAARBxAR/Q9ERP8DAABWUDggGAAAABQBAJ0BKgEAAQAAAP4AAA3AAP7mtQAAAA==',
  animation:
    'UklGRlIAAABXRUJQVlA4WAoAAAASAAAAAAAAAAAAQU5JTQYAAAD/////AABBTk1GJgAAAAAAAAAAAAAAAAAAAGQAAABWUDhMDQAAAC8AAAAQBxAREYiI/gcA',
};

export const webpSupportTest = (feature: string): Promise<Result> => {
  return new Promise((resolve, reject) => {
    const img = new Image();
    img.onload = () => {
      const result = img.width > 0 && img.height > 0;
      resolve({ result, feature, img });
    };
    img.onerror = (e) => reject(e);
    img.src = 'data:image/webp;base64,' + kTestImages[feature];
  });
};

export const isWebp = async (feature = 'lossless') => {
  const res = await webpSupportTest(feature).catch((e) => {
    console.log('onload error', e);
  });
  return res?.result;
};
