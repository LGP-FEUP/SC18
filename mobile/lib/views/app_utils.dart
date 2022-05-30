import 'dart:convert';

import 'package:flutter/services.dart';

class AppUtils {
  static Future<List<String>> getCountries() async {
    final manifestContent = await rootBundle.loadString('AssetManifest.json');
    final Map<String, dynamic> manifestMap = json.decode(manifestContent);
    final imagePaths = manifestMap.keys
        .where((String key) => key.contains('assets/flags/'))
        .where((String key) => key.contains('.svg'))
        .toList();

    return imagePaths
        .map((e) => e.replaceAll("assets/flags/", "").replaceAll(".svg", ""))
        .toList();
  }
}