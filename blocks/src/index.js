import './style.scss';
import { registerBlockType } from '@wordpress/blocks';
import * as learnerPath from './learner-path'
import * as learnerPathRow from './learner-path-row'
import * as podcasts from './podcasts'
import * as clToday from './cl-today'
import * as search from './search'
import * as suggestions from './suggestions'
import * as suggestionsRow from './suggestions-row'
import * as communityDiscussions from './community-discussions'
import * as clEvents from './cl-events'
import * as successStories from './success-stories'

const blocks = [
    communityDiscussions,
    clToday,
    clEvents,
    learnerPath,
    learnerPathRow,
    podcasts,
    search,
    suggestions,
    suggestionsRow,
    successStories
];

/**
 * Registers a new block provided a unique name(string) and an settings(object) defining its behavior.
 */
function registerBlock( block ) {
    const { name, settings } = block;
    registerBlockType( name, settings );
}
blocks.forEach( registerBlock );