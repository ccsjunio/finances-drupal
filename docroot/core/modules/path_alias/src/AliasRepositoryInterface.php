<?php

namespace Drupal\path_alias;

/**
 * Provides an interface for path alias lookup operations.
 *
 * The path alias repository service is only used internally in order to
 * optimize alias lookup queries needed in the critical path of each request.
 * However, it is not marked as an internal service because alternative storage
 * backends still need to override it if they provide a different storage class
 * for the PathAlias entity type.
 *
 * Whenever you need to determine whether an alias exists for a system path, or
 * whether a system path has an alias, the 'path_alias.manager' service should
 * be used instead.
 */
interface AliasRepositoryInterface {

  /**
   * Pre-loads path alias information for a given list of system paths.
   *
   * @param array $preloaded
   *   System paths that need preloading of aliases.
   * @param string $langcode
   *   Language code to search the path with. If there's no path defined for
   *   that language it will search paths without language.
   *
   * @return string[]
   *   System paths (keys) to alias (values) mapping.
   */
  public function preloadPathAlias($preloaded, $langcode);

  /**
   * Searches a path alias for a given Drupal system path.
   *
   * The default implementation performs case-insensitive matching on the
   * 'path' and 'alias' strings.
   *
   * @param string $path
   *   The system path to investigate for corresponding path aliases.
   * @param string $langcode
   *   Language code to search the path with. If there's no path defined for
   *   that language it will search paths without language.
   *
   * @return array|null
   *   An array containing the 'id', 'path', 'alias' and 'langcode' properties
   *   of a path alias, or NULL if none was found.
   */
  public function lookupBySystemPath($path, $langcode);

  /**
   * Searches a path alias for a given alias.
   *
   * The default implementation performs case-insensitive matching on the
   * 'path' and 'alias' strings.
   *
   * @param string $alias
   *   The alias to investigate for corresponding system paths.
   * @param string $langcode
   *   Language code to search the alias with. If there's no alias defined for
   *   that language it will search aliases without language.
   *
   * @return array|null
   *   An array containing the 'id', 'path', 'alias' and 'langcode' properties
   *   of a path alias, or NULL if none was found.
   */
  public function lookupByAlias($alias, $langcode);

  /**
   * Check if any alias exists starting with $initial_substring.
   *
   * @param string $initial_substring
   *   Initial system path substring to test against.
   *
   * @return bool
   *   TRUE if any alias exists, FALSE otherwise.
   */
  public function pathHasMatchingAlias($initial_substring);

}
