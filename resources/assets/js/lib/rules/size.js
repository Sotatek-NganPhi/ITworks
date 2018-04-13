export default (files, [size]) => {
  if (isNaN(size)) {
    return false;
  }

  const nSize = Number(size) * 1024;
  return files.every(file => file.size <= nSize);
};
