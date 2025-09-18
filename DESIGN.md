# Design

## My approach
I broke the problem into smaller parts so I could focus on one step at a time.  
First I got the data into a usable format, then I set up a way to organize it for fast lookups, and finally I worked through the calculations and edge cases before formatting the final JSON output.  

## Trade-offs
I chose to keep things simple with basic PHP string functions like `substr` and arrays.  
This made the code easy to follow, but it might not handle unusual date formats as well as a more robust solution would.  


## Next steps
I added a quick test, but if I had more time I’d add proper unit tests, more edge case checks, and error handling.  I’d also refactor parts of the code into functions and make the month/year filters configurable instead of hardcoded.

