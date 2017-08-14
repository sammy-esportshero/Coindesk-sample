# Coindesk-sample
EDIT (08/14/2017): This was a task assigned to me for an interview with CoinDesk. It is currently live on : https://secret-castle-77072.herokuapp.com/

Develop a "portfolio tracker" that shows return % for any given cryptocurrency portfolio over the past 24 hours.

The web frontend should allow a user to enter their portfolio's current balances and then show a return % figure
for the past 24 hours. For example, a user should be able to enter that their portfolio consists of 3 BTC, 20
ETH, and 6 LTC. After pressing submit, the user should see an overall return percentage displayed for this
portfolio over the past 24 hours (based on the performances of the individual assets over that period). See a
basic mockup below:

You will need to use the CoinCap API (https://github.com/CoinCapDev/CoinCap.io) to pull current and historical
prices for cryptocurrencies. These prices will be used to compute the overall return % for portfolios that users
submit. Note that for some of the more obscure cryptocurrencies, CoinCap has limited (or no) data – feel free
to restrict your app to just the top 10 cryptocurrencies (a fixed list is fine).

Tips
• For current cryptocurrency prices, use /front; for historical (24h), use /history/1day/<coin>.
Also, CoinCap’s data can be flaky at times so don’t worry about the final result being super accurate.
• You’re free to use whichever tech stack you’re comfortable with to build this; we’re just trying to get a
feel for how you write and architect your code, and aren’t testing for specific technologies.
• Don’t worry about creating a “finished product”. Catching small edge cases and making optimizations
is secondary to showing us your programming style. Perfectly clean code is also not necessary!
• Use any online resources (StackOverflow, CodePen, etc.) you’d like.
• We’re happy to answer any questions you have.
• Feel free to be creative and show us your stuff if you’d like, but there’s definitely no need to go
overboard. Don’t spend more than 2-4 hours on the overall project. Barebones is perfectly fine.
Submission

Please send over GitHub repo(s) for your code as well as a hosted version of your application for us to play
around with (suggested: Heroku if you have backend code, otherwise GitHub pages). Good luck!
