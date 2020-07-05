
#!/bin/sh
php artisan make:model Department -a && \
php artisan make:model Venue -a && \
php artisan make:model Event -a && \
php artisan make:model ReserveStatus -a && \
php artisan make:model EventReview -a && \
php artisan make:model Book -a && \
php artisan make:model Ticket -a && \
php artisan make:model BookTicket -a && \
php artisan make:model EventSpeaker -a && \
php artisan make:model Speaker -a && \
php artisan make:model Template -a && \
php artisan make:model Poster -a && \
php artisan make:model Attendee -a && \
php artisan make:model BookItem -a && \
php artisan make:model Subscriber -a && \
php artisan make:model Setting -a


