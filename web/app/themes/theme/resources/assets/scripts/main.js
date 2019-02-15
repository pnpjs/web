// import external dependencies
import 'jquery';

// Import everything from autoload
import './autoload/**/*'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import pageTemplateDefault from './routes/pageTemplateDefault';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
  // default page template
  pageTemplateDefault,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());

document.addEventListener('routed', e => {
  // the name of the route that fired (e.g., 'home')
  const routeName = e.detail.route;
  // the event that fired on the route (e.g., 'init')
  const routeEvent = e.detail.fn;

  console.log(routeName, routeEvent);
});
