BN Taxi – Booking & Approval System Requirements

1. Booking Information

Every booking should record:

* Unique booking reference number
* Date and time the booking was created/received
* Customer name
* Customer email address
* Customer telephone number
* Number of passengers
* Number of bags
* Pickup address
* Drop-off address
* Any via/stops between pickup and drop-off
* Pickup date and time
* Estimated journey time
* Estimated distance
* Flight number, where applicable
* Airport/flight origin or destination
* Flight arrival time, where applicable
* Special instructions/notes
* Payment method:
    * Online payment
    * Cash
* Booking status

2. Route Calculation

The system should automatically calculate the journey using a mapping/routing service such as Google Maps.

The route calculation should take into account:

* Pickup location
* Via/stops
* Final destination
* Estimated journey time
* Distance
* Current traffic where available
* Road closures and restrictions where the mapping service provides this information

The system should display the proposed route and estimated travel time to the administrator before the booking is confirmed.

3. Booking Workflow

When a customer submits a booking:

Step 1 – Booking received

The system creates a booking reference and records the exact date/time the booking was received.

The booking is immediately given the status:

PENDING APPROVAL

The customer receives an email confirming that their booking request has been received, but this email must clearly state that the booking is not yet confirmed.

The company/admin receives an immediate notification that a new booking is awaiting approval.

Step 2 – Admin review

The administrator reviews:

* Pickup and drop-off
* Via locations
* Date/time
* Number of passengers
* Number of bags
* Flight information
* Route and estimated journey time
* Payment method
* Any customer notes
* Whether the company has availability to complete the journey

The administrator can then:

CONFIRM BOOKING

or

REJECT BOOKING

Step 3 – Booking confirmed

If the administrator accepts the booking:

The booking status changes to:

CONFIRMED

The customer receives an email confirming that BN Taxi has accepted the booking and can complete the journey.

The confirmation email should include:

* Booking reference
* Pickup date/time
* Pickup address
* Via/stops
* Destination
* Passenger number
* Bag number
* Flight information, if applicable
* Payment method
* Any relevant booking instructions

The system should record the date/time the booking was confirmed and which administrator confirmed it.

4. Pending Booking Protection

A customer must not assume that a booking has been accepted simply because they submitted the online form.

The system should clearly distinguish between:

* Booking request received
* Pending approval
* Confirmed
* Rejected
* Cancelled
* Completed

If the customer has not received the confirmation email, the booking should remain unconfirmed.

The customer-facing system should clearly state that the booking is only accepted once BN Taxi has sent the confirmation email.

5. Automatic Rejection of Urgent Unapproved Bookings

The system should have an automatic protection mechanism for bookings that are approaching their pickup time.

For example:

If a booking is due to depart within 1 hour and it is still marked PENDING APPROVAL, the system should automatically flag it as urgent.

If the booking has not been reviewed/accepted by the required deadline, the system should automatically:

1. Mark the booking as REJECTED / NOT ACCEPTED
2. Record the reason as “Not approved within required timeframe”
3. Notify the customer by email that BN Taxi is unable to accept the booking
4. Notify the company/admin
5. Prevent the system from treating the booking as a confirmed job
6. Automatically process a refund where an online payment has already been taken, subject to the payment/refund rules

The exact deadline should be configurable by the administrator rather than permanently fixed at one hour.

For example:

* Standard bookings: approval required within a configurable period
* Bookings within 2 hours: urgent notification
* Bookings within 1 hour: automatic rejection if still unapproved

6. Payments

The system should support:

Online payment

The customer can pay when making the booking.

The payment should initially be associated with the booking and should not be treated as a completed/accepted booking until the company’s approval process is complete.

If the booking is rejected or cancelled under the applicable refund rules, the system should allow the administrator to process a full or partial refund.

Cash

The customer can select cash payment.

The booking should record:

Payment method: CASH

No online payment should be taken.

The system should allow the driver/admin to record whether cash was eventually received.

7. Cancellation

Customers should be able to request/carry out cancellation through the system, subject to the company’s cancellation policy.

The system should record:

* Who cancelled the booking
* Date/time of cancellation
* Reason for cancellation
* Refund amount
* Refund status
* Payment transaction/reference

Administrators should be able to cancel bookings from the admin system.

The cancellation/refund rules should be configurable, for example:

* Full refund
* Partial refund
* No refund
* Refund depending on how close cancellation is to pickup time

8. Flight Information

For airport bookings, the booking form should allow the customer to enter:

* Flight number
* Airline
* Airport
* Arrival/departure
* Scheduled flight time
* Origin/destination

The system should retain this information against the booking.

Where technically possible, the system could also integrate with a flight-status service to monitor delays/cancellations and notify the company.

9. Notifications

Customer

The customer should receive emails for:

* Booking request received
* Booking confirmed
* Booking rejected
* Booking cancelled
* Refund processed
* Other important booking updates

Company/Admin

The company should receive notifications for:

* New booking received
* Booking awaiting approval
* Urgent booking approaching pickup time
* Booking automatically rejected
* Customer cancellation
* Payment received
* Refund processed

Notifications should ideally be available by:

* Email
* Admin dashboard
* Optional SMS/push notification

10. Admin Dashboard

The administrator should have a dashboard showing all bookings.

Bookings should be filterable by:

* Pending approval
* Confirmed
* Rejected
* Cancelled
* Completed
* Today’s bookings
* Tomorrow’s bookings
* Airport bookings
* Online payments
* Cash payments
* Urgent/unapproved bookings

Each booking should have a full timeline showing:

* Booking received
* Customer emails sent
* Admin notifications sent
* Booking reviewed
* Booking confirmed/rejected
* Payment received
* Cancellation
* Refund
* Other status changes

This audit trail is important so BN Taxi can see exactly what happened with every booking.

11. Important Booking Rule

The system should enforce the following principle:

A booking request is NOT a confirmed booking until an administrator has approved it and the customer has received the official BN Taxi confirmation email.

This should be made clear to the customer during the booking process.

12. Suggested Booking Statuses

Use the following statuses:

NEW → PENDING APPROVAL → CONFIRMED → DRIVER ASSIGNED → IN PROGRESS → COMPLETED

Alternative outcomes:

PENDING APPROVAL → REJECTED

CONFIRMED → CANCELLED

REJECTED/CANCELLED → REFUND PROCESSING → REFUNDED

13. Automatic Safety/Time Rules