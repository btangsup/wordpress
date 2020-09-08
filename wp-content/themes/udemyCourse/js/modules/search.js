import $ from 'jquery';

class Search {

    // describe and create intiate our object
    constructor() {
        this.addSearchHTML(); // needs to be called first because other constructor properties rely on this
        this.resultsDiv = $("#search-overlay__results");
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchInput = $("#search-term");
        this.events();
        this.isOverlayOpen = false;
        this.isLoading = false;
        this.typingTimer;
        this.previousValue;
    }

    // EVENTS

    events() {
        this.openButton.on("click", this.openOverlay.bind(this)); // need to bind buttons cause jquery
        this.closeButton.on("click", this.closeOverLay.bind(this));
        $(document).on('keydown', this.keyPressDispatcher.bind(this));
        this.searchInput.on('keyup', this.userInput.bind(this));
    }

    // METHODS (FUNCTIONS)

    userInput() {
        if(this.searchInput.val() != this.previousValue) {
            clearTimeout(this.typingTimer);
            if (this.searchInput.val()) {
                if (!this.isLoading) {
                    this.resultsDiv.html('<div class="spinner-loader"></div>')
                    this.isLoading = true;
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 750);
            } else {
                this.resultsDiv.html('');
                this.isLoading = false;
            } 
        }
        this.previousValue = this.searchInput.val();
    }

    getResults() {

        // uses CUSTOMIZABLE API
        $.getJSON(universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchInput.val(), (results) => {
            this.resultsDiv.html(`
                <div class="row">
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">General Information</h2>
                        ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>No general information matches that search</p>'}
                        ${results.generalInfo.map(item => `<li><a href="${item.url}">${item.title}</a> ${item.postType == 'post' ? `by ${item.author}` : ''}</li>`).join('')}
                        ${results.generalInfo.length ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Programs</h2>
                        ${results.programs.length ? '<ul class="link-list min-list">' : `<p>No programs information matches that search. <a href="${universityData.root_url}">View all programs</a></p>`}
                        ${results.programs.map(item => `<li><a href="${item.url}">${item.title}</a></li>`).join('')}
                        ${results.programs.length ? '</ul>' : ''}
                        <h2 class="search-overlay__section-title">Professors</h2>
                        ${results.professors.length ? '<ul class="professor-cards">' : `<p>No professors information matches that search. </p>`}
                        ${results.professors.map(item => `
                                <li class="professor-card__list-item">
                                    <a class="professor-card" href="${item.url}">
                                        <img class="professor-card__image" src="${item.image}>" alt="">
                                        <span class="professor-card__name">${item.title}</span>
                                    </a>
                                </li>
                            `).join('')}
                        ${results.professors.length ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Campuses</h2>
                        ${results.campuses.length ? '<ul class="link-list min-list">' : `<p>No campus information matches that search. <a href="${universityData.root_url}">View all campuses</a></p>`}
                        ${results.campuses.map(item => `<li><a href="${item.url}">${item.title}</a></li>`).join('')}
                        ${results.campuses.length ? '</ul>' : ''}
                        <h2 class="search-overlay__section-title">Events</h2>
                        ${results.events.length ? '<ul class="link-list min-list">' : `<p>No events matches that search. <a href="${universityData.root_url}/events">View all events</a></p>`}
                        ${results.events.map(item => `
                        <div class="event-summary">
                            <a class="event-summary__date t-center" href="#">
                                <span class="event-summary__month">${item.month}</span>
                                <span class="event-summary__day">${item.day}</span>  
                            </a>
                            <div class="event-summary__content">
                                <h5 class="event-summary__title headline headline--tiny"><a href="${item.url}">${item.title}</a></h5>
                                <p>${item.description} <a href="${item.url}" class="nu gray">Learn more</a></p>
                            </div>
                        </div>
                        `).join('')}
                        ${results.events.length ? '</ul>' : ''}
                    </div>
                </div>
            `)
        })

        // one way that uses the WP API SEARCH QUERY
        // $.when(
        //     $.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchInput.val()),
        //     $.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchInput.val())
        // ).then((posts, pages)=> {
        //     const combinedResults = posts.concat(pages); // this combines pages and posts for the api request
        //     this.resultsDiv.html(
        //         `
        //         <h2 class="search-overlay__section-title">General Information</h2>
        //         ${combinedResults.length ? '<ul class="link-list min-list">' : '<p>No general information matches that search</p>'}
        //             ${combinedResults.map(item => `<li><a href="${item.link}">${item.slug}</a> ${item.type == 'post' ? `by ${item.authorName}`: ''}</li>`).join('')}
        //         ${combinedResults.length ? '</ul>' : ''}
        //         `)
        //     this.isLoading = false;
        // }, () => {
        //     this.resultsDiv.html('<p>Unexpected error, please try again</p>');
        // });
    }

    keyPressDispatcher(e) {
        if(e.keyCode === 83 && this.isOverlayOpen === false) {
            this.openOverlay();
        }

        if(e.keyCode === 27) {
            this.closeOverLay();
        }
    }

    openOverlay() {
        this.searchOverlay.addClass('search-overlay--active');
        $("body").addClass("body-no-scroll");
        // this.searchInput.val(''); // this clears input field when reopening
        setTimeout(() => this.searchInput.focus(), 301); // create an arrow function for set timeout to target focus when opening layotut
        this.isOverLayOpen = true;
    }

    closeOverLay() {
        this.searchOverlay.removeClass('search-overlay--active');
        $("body").removeClass("body-no-scroll");
        console.log('closing');
        this.isOverLayOpen = false;
    }

    addSearchHTML() {
        $("body").append(`
        <div class="search-overlay">
            <div class="search-overlay__top">
                <div class="container">
                    <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                    <input type="text" class="search-term" placeholder="What are ya looking for?" id="search-term">
                    <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                </div>
            </div>
            <div class="container">
                <div id="search-overlay__results">
                    
                </div>
            </div>
        </div>
        `)
    }
}

export default Search;