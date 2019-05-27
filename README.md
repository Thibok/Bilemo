<h1>Bilemo Api</h1>
<a href="https://www.codacy.com/app/Thibok/Bilemo?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Thibok/Bilemo&amp;utm_campaign=Badge_Grade"><img src="https://api.codacy.com/project/badge/Grade/05b1a936dcb64462a2a45a40ccec8be2"/></a>
<p>Welcome on the Bilemo Api project ! This project was realized under <strong>Symfony 3.4</strong>.
This project is for my training at Openclassroom on the DA PHP/Symfony path.This is my seventh project, for which I need to create a Api REST phone sales app.<br/>
For more help on how Api works, read the <a href="https://app.swaggerhub.com/apis-docs/Thibok/Bilemo/1.0.0">documentation</a><br/>
If you want to use the Frontend app, go <a href="https://github.com/Thibok/Frontend_Bilemo">here</a>
<h2>Prerequisites</h2>
<ul>
  <li>PHP 7.3</li>
  <li>Mysql</li>
  <li>Apache</li>
</ul>
<h2>Framework</h2>
<ul>
  <li>Symfony</li>
</ul>
<h2>ORM</h2>
<ul>
  <li>Doctrine</li>
</ul>
<h2>Bundles</h2>
<ul>
  <li>friendsofsymfony/rest-bundle</li>
  <li>csa/guzzle-bundle</li>
  <li>white-october/pagerfanta-bundle</li>
  <li>willdurand/hateoas-bundle</li>
  <li>jms/serializer-bundle</li>
  <li>doctrine/doctrine-fixtures-bundle</li>
</ul>
<h2>Getting started</h2>
<h4>Create Facebook app</h4>
<p>Before you install the project, go to the <a href="https://developers.facebook.com/">Facebook Developers</a> site and sign in.Then go to your space <a href="https://developers.facebook.com/apps">here</a> and create a new app.</p>
<h4>Create demo users</h4>
<p>For create demo users, go to your Facebook app space, click on <strong>Roles</strong> and then on <strong>Test Users</strong>.Create two users with the <strong>Add</strong> button.</p>
<h2>Installation</h2>
<h4>Clone project :</h4>
<pre>git clone https://github.com/Thibok/Bilemo.git</pre>
<h4>Install dependencies :</h4>
<pre>composer install</pre>
<h4>Create database :</h4>
<pre>php bin/console doctrine:database:create</pre>
<h4>Update schema :</h4>
<pre>php bin/console doctrine:schema:update --force</pre>
<h4>Update demo users</h4>
<p>Go in src/AppBundle/DataFixtures/UserFixtures.php and set on lines 62 and 63 your Facebook users demo informations in this order : user ID, first name, last name</p>
<h4>Load fixtures :</h4>
<pre>php bin/console doctrine:fixture:load</pre>
<h4>Retrieve an access token</h4>
<p>For access to Api, you need access token.For obtain it you can use the <a href="https://github.com/Thibok/Frontend_Bilemo">Frontend App</a> and sign in with your Facebook account or use a Facebook demo user.For get an access token for a demo user, go to your Facebook app space, choose an user then click on <strong>Edit</strong> and then <strong>Obtain an access token for this test user</strong></p>
<h4>Run It !</h4>
<p>Now you can start your server with this :</p>
<pre>php bin/console server:start</pre>
<p>For your requests, remember to use the <strong>Authorization</strong> header and add your access token to <strong>Bearer</strong> (RFC 6750)</p>
<pre>Bearer yourAccessToken</pre>
<strong>And go on the local address !</strong>
<strong>Don't forget to read the <a href="https://app.swaggerhub.com/apis-docs/Thibok/Bilemo/1.0.0">documentation</a></strong>
<h2>Tests</h2>
<p>If you need run tests :</p> 
<h4>Create test database :</h4>
<pre>php bin/console doctrine:database:create --env=test</pre>
<h4>Update schema :</h4>
<pre>php bin/console doctrine:schema:update --force --env=test</pre>
<h4>Create a test app</h4>
<p>Go to your Facebook app space and click on <strong>Create a test app</strong></p>
<h4>Create test users</h4>
<p>Always in your Facebook app space, create two tests users in your test app and obtain access token for them.</p>
<h4>Update tests user</h4>
<p>Go in app/config/parameters.yml and set fb_test_main_access_token and fb_test_secondary_access_token with access tokens of your test users</p>
<p>Go in src/DataFixtures/UserFixtures.php and set on lines 54 and 55 your Facebook users test informations in this order : user ID, first name, last name</p>
<h4>Load test fixtures :</h4>
<pre>php bin/console doctrine:fixture:load --env="test"</pre>
<h4>Run tests !</h4>
<pre>vendor/bin/phpunit</pre>
<h2>Production</h2>
<p>If you want to use production environment, don't forget :</p>
<h4>Clear cache :</h4>
<pre>php bin/console cache:clear --env="prod"</pre>
