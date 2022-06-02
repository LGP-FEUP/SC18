import 'package:cached_network_image/cached_network_image.dart';
import 'package:erasmus_helper/models/culture_entry.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../../../services/culture_service.dart';
import '../../app_topbar.dart';
import 'components/culture_content.dart';

class CultureDetails extends StatelessWidget {
  final CultureEntry entry;

  const CultureDetails(this.entry, {Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final screenHeight = MediaQuery.of(context).size.height;

    return AppTopBar(
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
                  height: 240.0,
                  child: FutureBuilder(
                    future: CultureService.getCultureEntryImage(entry.uid),
                    builder: (context, response) {
                      if (response.connectionState == ConnectionState.done) {
                        if (response.data != null) {
                          String url = response.data as String;
                          return CachedNetworkImage(
                            imageUrl: url,
                            height: screenHeight * 0.6,
                            fit: BoxFit.cover,
                            width: screenWidth,
                          );
                        }
                      }
                      return Container();
                    },
                  ),
                ),
                const CultureContent(),
              ],
            ),
          ),
        ));
  }
}
