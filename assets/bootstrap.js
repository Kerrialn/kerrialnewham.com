import {startStimulusApp} from '@symfony/stimulus-bundle';
import Clipboard from '@stimulus-components/clipboard'
import ScrollProgress from '@stimulus-components/scroll-progress'

const app = startStimulusApp();
app.register('clipboard', Clipboard)
app.register('scroll-progress', ScrollProgress)