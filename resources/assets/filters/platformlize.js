import Utils from '../js/common/Utils'

const PLATFORM_NAMES = ['PC', 'Mobile']

export default (value) => {
  if (!value && value !== 0) return ''
  const platformFlag = Number(value)
  const platforms = Utils.resolvePlatforms(platformFlag)

  return platforms.map(platform => PLATFORM_NAMES[platform]).join('/')
}