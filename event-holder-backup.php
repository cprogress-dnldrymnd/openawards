<div class="event-holder">
    <div class="row no-gutters">
        <div class="col-md-4">
            <div class="column-holder">
                <div class="image-box">
                    #_EVENTIMAGE{300,300}
                    <div class="date">
                        <span class="month">
                            #_{F}
                        </span>
                        <span class="day">
                            #_{d}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="column-holder event-details">
                #_EVENTCATEGORIES
                <div class="heading-box">
                    <h2>#_EVENTLINK</h2>
                    <span>[event_price minvalue="#_EVENTPRICEMIN" maxvalue="#_EVENTPRICEMAX"]</span>

                </div>
                <div class="meta-box">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="column-holder meta-holder meta-date">
                                <span class="meta-label"><strong>Date</strong></span>
                                <span class="meta-value">#_{d F Y}</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="column-holder meta-holder meta-time">
                                <span class="meta-label"><strong>Time</strong></span>
                                <span class="meta-value">#_EVENTTIMES</span>
                            </div>
                        </div>
                        {has_location}
                        <div class="col-sm-4">
                            <div class="column-holder meta-holder meta-location">
                                <span class="meta-label"><strong>Location</strong></span>
                                <span class="meta-value">#_LOCATIONNAME, #_LOCATIONPOSTCODE</span>
                            </div>
                        </div>
                        {/has_location}
                    </div>
                </div>
                <div class="button-box">
                    <a href="#_EVENTURL" class="button purple-bordered">View Event</a>
                    {has_bookings}
                    <a href="#_EVENTURL?book_ticket=yes" class="button primary">Book Tickets</a>
                    {/has_bookings}
                </div>
            </div>
        </div>
    </div>
</div>