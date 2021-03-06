<?php

namespace AppBundle\Security;

use AppBundle\Api\ApiProblem;
use AppBundle\Api\ResponseFactory;
use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class JwtTokenAuthenticator extends AbstractGuardAuthenticator
{
  /**
   * @var \Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface
   */
  private $jwtEncoder;
  /**
   * @var \Doctrine\ORM\EntityManager
   */
  private $em;
  /**
   * @var \AppBundle\Api\ResponseFactory
   */
  private $responseFactory;


  /**
   * JwtTokenAuthenticator constructor.
   */
  public function __construct(JWTEncoderInterface $jwtEncoder, EntityManager $em, ResponseFactory $responseFactory) {

    $this->jwtEncoder = $jwtEncoder;
    $this->em = $em;
    $this->responseFactory = $responseFactory;
  }

  public function getCredentials(Request $request)
  {
    $extractor = new AuthorizationHeaderTokenExtractor(
      'Bearer',
      'Authorization'
    );
    $token = $extractor->extract($request);

    if (!$token) {
      return;
    }

    return $token;
  }

  public function getUser($credentials, UserProviderInterface $userProvider)
  {
    // Does an encode and uses jwt libs to make sure the token has not been
    // changed, and that the token has not expired
    $data = $this->jwtEncoder->decode($credentials);

    if ($data === false) {
      throw new CustomUserMessageAuthenticationException('Invalid Token');
    }

    $username = $data['username'];

    return $this->em->getRepository('UserBundle:User')
      ->findOneBy(['email' => $username]);
  }

  public function checkCredentials($credentials, UserInterface $user) {
    return true;
  }

  public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
    // TODO: Implement onAuthenticationFailure() method.
  }

  public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) {
    // do nothing
  }

  public function supportsRememberMe() {
    return false;
  }

  public function start(Request $request, AuthenticationException $authException = NULL) {
    $apiProblem = new ApiProblem(401);
    $message = $authException ? $authException->getMessageKey() : 'Missing Credentials';
    $apiProblem->set('details', $message);

    return $this->responseFactory->createResponse($apiProblem);
  }

}