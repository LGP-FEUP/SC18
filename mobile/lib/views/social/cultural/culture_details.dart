import 'package:erasmus_helper/layout.dart';
import 'package:erasmus_helper/models/culture_entry.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../../app_topbar.dart';
import 'components/culture_content.dart';

class CultureDetails extends StatelessWidget {
  final CultureEntry entry;

  const CultureDetails(this.entry, {Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final screenHeight = MediaQuery.of(context).size.height;

    return AppLayout(
        title: entry.title,
        activateBackButton: true,
        body: Provider<CultureEntry>.value(
          value: entry,
          child: SingleChildScrollView(
            scrollDirection: Axis.vertical,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: <Widget>[
                SizedBox(
                  child: Image.asset(
                    entry.imagePath,
                    fit: BoxFit.cover,
                    height: screenHeight * 0.6,
                    width: screenWidth,
                  ),
                  height: 240.0,
                ),
                const CultureContent(),
              ],
            ),
          ),
        ));
  }
}
