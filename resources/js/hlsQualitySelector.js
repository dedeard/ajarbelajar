import ConcreteButton from 'videojs-hls-quality-selector/src/ConcreteButton'
import ConcreteMenuItem from 'videojs-hls-quality-selector/src/ConcreteMenuItem'

class HlsQualitySelectorPlugin {
  constructor(player, options) {
    this.player = player
    this.config = options
    this.createQualityButton()
    this.bindPlayerEvents()
  }

  bindPlayerEvents() {
    this.player
      .qualityLevels()
      .on('addqualitylevel', this.onAddQualityLevel.bind(this))
  }

  createQualityButton() {
    const player = this.player
    this._qualityButton = new ConcreteButton(player)
    const placementIndex = player.controlBar.children().length - 2
    const concreteButtonInstance = player.controlBar.addChild(
      this._qualityButton,
      { componentClass: 'qualitySelector' },
      this.config.placementIndex || placementIndex,
    )

    concreteButtonInstance.addClass('vjs-quality-selector')
    if (!this.config.displayCurrentQuality) {
      const icon = ` ${this.config.vjsIconClass || 'vjs-icon-hd'}`
      concreteButtonInstance.menuButton_.$('.vjs-icon-placeholder').className +=
        icon
    } else {
      this.setButtonInnerText('auto')
    }
    concreteButtonInstance.removeClass('vjs-hidden')
  }

  setButtonInnerText(text) {
    this._qualityButton.menuButton_.$('.vjs-icon-placeholder').innerHTML = text
  }

  getQualityMenuItem(item) {
    const player = this.player
    return new ConcreteMenuItem(player, item, this._qualityButton, this)
  }

  onAddQualityLevel() {
    const player = this.player
    const qualityList = player.qualityLevels()
    const levels = qualityList.levels_ || []
    const levelItems = []

    for (let i = 0; i < levels.length; ++i) {
      if (
        !levelItems.filter((_existingItem) => {
          return (
            _existingItem.item && _existingItem.item.value === levels[i].height
          )
        }).length
      ) {
        const levelItem = this.getQualityMenuItem.call(this, {
          label: levels[i].height + 'p',
          value: levels[i].height,
        })

        levelItems.push(levelItem)
      }
    }

    levelItems.sort((current, next) => {
      if (typeof current !== 'object' || typeof next !== 'object') {
        return -1
      }
      if (current.item.value < next.item.value) {
        return -1
      }
      if (current.item.value > next.item.value) {
        return 1
      }
      return 0
    })

    levelItems.push(
      this.getQualityMenuItem.call(this, {
        label: player.localize('Auto'),
        value: 'auto',
        selected: true,
      }),
    )

    if (this._qualityButton) {
      this._qualityButton.createItems = function () {
        return levelItems
      }
      this._qualityButton.update()
    }
  }

  setQuality(height) {
    const qualityList = this.player.qualityLevels()
    this._currentQuality = height

    if (this.config.displayCurrentQuality) {
      this.setButtonInnerText(height === 'auto' ? height : `${height}p`)
    }

    for (let i = 0; i < qualityList.length; ++i) {
      const quality = qualityList[i]
      quality.enabled = quality.height === height || height === 'auto'
    }
    this._qualityButton.unpressButton()
  }

  getCurrentQuality() {
    return this._currentQuality || 'auto'
  }
}

export default function hlsQualitySelector(videojs) {
  const onPlayerReady = (player, options) => {
    player.addClass('vjs-hls-quality-selector')
    player.hlsQualitySelector = new HlsQualitySelectorPlugin(player, options)
  }

  const hlsQualitySelector = function (options) {
    this.ready(() => {
      onPlayerReady(this, videojs.obj.merge(options))
    })
  }

  videojs.registerPlugin('hlsQualitySelector', hlsQualitySelector)
}
